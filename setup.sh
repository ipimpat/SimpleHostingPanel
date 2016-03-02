#!/bin/bash
echo Please enter MySQL root password
read ROOTPW
echo Please enter new ProFTPD password.
read PROFTPDPW

# Creating MySQL user and database
echo Creating database...
mysql -uroot -p$ROOTPW -e "CREATE DATABASE shp_database; GRANT SELECT, INSERT, UPDATE, DELETE ON shp_database.* TO 'proftpd'@'localhost' IDENTIFIED BY '$PROFTPDPW'; GRANT SELECT, INSERT, UPDATE, DELETE ON shp_database.* TO 'proftpd'@'localhost.localdomain' IDENTIFIED BY '$PROFTPDPW'; FLUSH PRIVILEGES;"
echo Creating database done


#Import SHP database
echo Importing SHP database...
mysql -p$ROOTPW -h localhost shp_database < sql/shp_database.sql
echo Importing SHP database done


# Create administrator
echo Please enter new admin username for web panel
read ADMIN
echo Please enter password
read PASSWORD
echo Please enter Email
read EMAIL
DATE=$date +%s
echo Inserting user information...
mysql -uroot -p$ROOTPW -e "INSERT INTO shp_database.administrators (username, password, email, added) VALUES ('$ADMIN', md5('$PASSWORD'), '$EMAIL', '$DATE');"
echo Inserting user information done

# Create modules.conf
echo Moving old config...
mv /etc/proftpd/modules.conf /etc/proftpd/modules.conf.old
echo Moving old config done
echo Creating new config...
touch /etc/proftpd/modules.conf
echo 'ModulePath /usr/lib/proftpd
ModuleControlsACLs insmod,rmmod allow user root
ModuleControlsACLs lsmod allow user *
LoadModule mod_ctrls_admin.c
LoadModule mod_tls.c
LoadModule mod_sql.c
LoadModule mod_sql_mysql.c
LoadModule mod_radius.c
LoadModule mod_quotatab.c
LoadModule mod_quotatab_file.c
LoadModule mod_quotatab_radius.c
LoadModule mod_wrap.c
LoadModule mod_rewrite.c
LoadModule mod_load.c
LoadModule mod_ban.c
LoadModule mod_wrap2.c
LoadModule mod_wrap2_file.c
LoadModule mod_dynmasq.c
LoadModule mod_ifsession.c' > /etc/proftpd/modules.conf
echo Creating new config done
# Create proftpd conf
echo Moving old config...
mv /etc/proftpd/proftpd.conf /etc/proftpd/proftpd.conf.old
echo Moving old config done
echo Creating new config...
touch /etc/proftpd/proftpd.conf
echo 'Include /etc/proftpd/modules.conf
UseIPv6			off
IdentLookups			off
ServerName			"Debian"
ServerType			standalone
DeferWelcome			off
MultilineRFC2228		on
DefaultServer			on
ShowSymlinks			on
TimeoutNoTransfer		600
TimeoutStalled		600
TimeoutIdle			1200
DisplayLogin                welcome.msg
DisplayChdir               	.message true
ListOptions                	"-l"
DenyFilter			\*.*/
Port				21
<IfModule mod_dynmasq.c>
# DynMasqRefresh 28800
</IfModule>
MaxInstances			30
User				proftpd
Group				nogroup
Umask				022  022
AllowOverwrite		on
TransferLog /var/log/proftpd/xferlog
SystemLog   /var/log/proftpd/proftpd.log
<IfModule mod_ratio.c>
Ratios off
</IfModule>
<IfModule mod_delay.c>
DelayEngine on
</IfModule>
<IfModule mod_ctrls.c>
ControlsEngine        off
ControlsMaxClients    2
ControlsLog           /var/log/proftpd/controls.log
ControlsInterval      5
ControlsSocket        /var/run/proftpd/proftpd.sock
</IfModule>
<IfModule mod_ctrls_admin.c>
AdminControlsEngine off
</IfModule>
DefaultRoot ~
SQLBackend              mysql
SQLAuthTypes            Plaintext Crypt
SQLAuthenticate         users groups
SQLConnectInfo  shp_database@localhost proftpd '$PROFTPDPW'
SQLUserInfo     ftpuser userid passwd uid gid homedir shell
SQLGroupInfo    ftpgroup groupname gid members
SQLMinID        500
CreateHome on 755
SQLLog PASS updatecount
SQLNamedQuery updatecount UPDATE "count=count+1, accessed=now() WHERE userid='%u'" ftpuser
SQLLog  STOR,DELE modified
SQLNamedQuery modified UPDATE "modified=now() WHERE userid='%u'" ftpuser
QuotaEngine on
QuotaDirectoryTally on
QuotaDisplayUnits Mb
QuotaShowQuotas on
SQLNamedQuery get-quota-limit SELECT "name, quota_type, per_session, limit_type, bytes_in_avail, bytes_out_avail, bytes_xfer_avail, files_in_avail, files_out_avail, files_xfer_avail FROM ftpquotalimits WHERE name = '%{0}' AND quota_type = '%{1}'"
SQLNamedQuery get-quota-tally SELECT "name, quota_type, bytes_in_used, bytes_out_used, bytes_xfer_used, files_in_used, files_out_used, files_xfer_used FROM ftpquotatallies WHERE name = '%{0}' AND quota_type = '%{1}'"
SQLNamedQuery update-quota-tally UPDATE "bytes_in_used = bytes_in_used + %{0}, bytes_out_used = bytes_out_used + %{1}, bytes_xfer_used = bytes_xfer_used + %{2}, files_in_used = files_in_used + %{3}, files_out_used = files_out_used + %{4}, files_xfer_used = files_xfer_used + %{5} WHERE name = '%{6}' AND quota_type = '%{7}'" ftpquotatallies
SQLNamedQuery insert-quota-tally INSERT "%{0}, %{1}, %{2}, %{3}, %{4}, %{5}, %{6}, %{7}" ftpquotatallies
QuotaLimitTable sql:/get-quota-limit
QuotaTallyTable sql:/get-quota-tally/update-quota-tally/insert-quota-tally
RootLogin off
RequireValidShell off' > /etc/proftpd/proftpd.conf
echo Creating new config done

# add user and group for ftpd
echo Adding users for proftpd...
groupadd -g 2001 ftpgroup
useradd -u 2001 -s /bin/false -d /bin/null -c "proftpd user" -g ftpgroup ftpuser
echo Adding users for proftpd done

echo Removing default apache config...
rm /etc/apache2/sites-enabled/000-default
echo Removing default apache config done
echo Creating new apache config...
touch /etc/apache2/sites-enabled/000-default
echo '<VirtualHost *:80>
	ServerAdmin '$EMAIL'
	
	DocumentRoot /var/www/
	<Directory />
		Options FollowSymLinks
		AllowOverride None
	</Directory>
	<Directory /var/www/>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride None
		Order allow,deny
		allow from all
	</Directory>
	ErrorLog /var/log/apache2/error.log

	# Possible values include: debug, info, notice, warn, error, crit,
	# alert, emerg.
	LogLevel warn

	CustomLog /var/log/apache2/access.log combined
</VirtualHost>' > /etc/apache2/sites-enabled/000-default
echo Creating new apache config done

#Copy www files
echo Copying files...
cp -r www/ /var
echo Copying files done

# remove default index file
echo Removing default index file...
rm /var/www/index.html
echo Removing default index file done

# Make needed dirs
echo Creating dirs... 
mkdir /var/users
mkdir /var/users/logs
echo Creating dirs done

#Cronjobs
echo Installing cronjobs...
chmod 755 /var/www/cron_scripts/create_vhost.php
chmod 755 /var/www/cron_scripts/delete_vhost.php
echo '* *    * * *    root    php /var/www/cron_scripts/create_vhost.php &> /dev/null
* *    * * *    root    php /var/www/cron_scripts/delete_vhost.php &> /dev/null' >> /etc/crontab
echo Installing cronjobs done

# DB CONN file
echo Creating db conn file...
echo '<?
mysql_connect("localhost", "root", "'$ROOTPW'") or die(mysql_error());
mysql_select_db("shp_database") or die(mysql_error());
?>' > /var/www/includes/dbconnect.inc.php
echo Creating db conn file done

# Restart services
echo Restarting services...
/etc/init.d/proftpd restart
/etc/init.d/apache2 reload
echo Restarting services done