#!/usr/bin/env bash

_init_ssh_client(){
        cp /.ssh/id_rsa /root/.ssh/
        chmod 600 /root/.ssh/id_rsa
	ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no root@pgsql -i /root/.ssh/id_rsa 'cat /credentials' >> /credentials
	ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no root@pgadmin -i /root/.ssh/id_rsa 'cat /credentials' >> /credentials
	ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no root@ftp -i /root/.ssh/id_rsa 'cat /credentials' >> /credentials
	chown www-data:www-data /credentials
}

if [[ $FIRST_START == "true" ]]; then
	a2enmod ssl
	a2enmod rewrite
	a2ensite main_http.conf
	a2ensite main_https.conf
	a2dissite 000-default.conf
	a2dissite default-ssl.conf
	export FIRST_START="false"
fi

_init_ssh_client

if [ ! -d "/mnt/NFS/dst/" ]; then
	mkdir /mnt/NFS/dst/
fi
if [ ! -d "/var/www/html/resource/" ]; then
        mkdir /var/www/html/resource/
fi
if [ ! -d "/var/www/html/web_test_1/" ]; then
        mkdir /var/www/html/web_test_1/
fi
if [ ! -d "/var/www/html/web_test_2/" ]; then
        mkdir /var/www/html/web_test_2/
fi
if [ ! -d "/var/www/html/web_test_3/" ]; then
        mkdir /var/www/html/web_test_3/
fi

#chown www-data:www-data /var/www -R
#chmod g+w /var/www -R
ln -s /mnt/NFS/dst /var/www/html/resource/
sed -i 's/^Define port .*/Define port '${HTTPS_PORT}'/I' /etc/apache2/sites-available/main_http.conf
sed -i 's/^Define port_test_1 .*/Define port_test_1 '${HTTPS_PORT_TEST_1}'/I' /etc/apache2/sites-available/main_http.conf
sed -i 's/^Define port_test_2 .*/Define port_test_2 '${HTTPS_PORT_TEST_2}'/I' /etc/apache2/sites-available/main_http.conf
sed -i 's/^Define port_test_3 .*/Define port_test_3 '${HTTPS_PORT_TEST_3}'/I' /etc/apache2/sites-available/main_http.conf
#cat /etc/apache2/sites-available/main_http.conf
#echo $FIRST_START
#service apache2 restart

apachectl -D FOREGROUND
#ls -all /mnt/NFS/

#FILES="/etc/ssl/common/"
#for f in $FILES
#do
  # take action on each file. $f store current file name
#  echo "$f"
#done
