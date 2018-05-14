#!/bin/bash

##
# This script was not tested. Do not use in production!
##

adduser --quiet --system --no-create-home --group serveradmin
mkdir -p /opt/serveradmin/storage/logs /opt/serveradmin/public

apt update -y
apt full-upgrade -y

apt install -y software-properties-common python-software-properties

# UFW
apt install -y ufw

# MariaDB
apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xF1656F24C74CD1D8
add-apt-repository 'deb [arch=amd64,i386,ppc64el] http://ams2.mirrors.digitalocean.com/mariadb/repo/10.2/ubuntu xenial main'
apt update -y
apt install -y mariadb-server
# CONF

# Bind9
apt install -y bind9 bind9utils
# CONF

# Postfix, Dovecot
apt install -y postfix postfix-mysql dovecot-core dovecot-imapd dovecot-pop3d dovecot-lmtpd dovecot-mysql
# CONF
chmod o-rwx /etc/postfix/mysql-virtual-*
mkdir -p /var/mail/vhosts/
groupadd -g 5000 vmail
useradd -g vmail -u 5000 vmail -d /var/mail
chown -R vmail:vmail /var/mail

# Nginx, PHP 7.1
add-apt-repository -y ppa:ondrej/php
add-apt-repository -y ppa:nginx/stable
apt update -y
apt --purge remove 'apache2*'
apt install -y nginx php7.1 php7.1-cli php7.1-fpm php7.1-curl php7.1-xml php7.1-zip php7.1-gd php7.1-mysql php7.1-mbstring
rm /etc/nginx/sites-available/*
rm /etc/nginx/sites-enabled/*
rm /etc/php/7.1/fpm/pool.d/*
# CONF
ln -s /etc/nginx/sites-available/serveradmin.conf /etc/nginx/sites-enabled/serveradmin.conf

# ServerAdmin
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
cd /opt/serveradmin
chown -R serveradmin:serveradmin .
sudo -u serveradmin composer install
sudo -u serveradmin php artisan migrate

