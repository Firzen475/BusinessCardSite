#!/usr/bin/env bash

_init_bind9_config(){
	cp /named.conf.options /etc/bind/named.conf.options
	echo "include \"/var/lib/samba/bind-dns/named.conf\";" >> /etc/bind/named.conf.local
	cat /etc/bind/named.conf.local
	#echo "/////////////////////"
	#echo "/////////////////////"

}

echo "DC1" >> /etc/hostname
echo "Проверка имени"
hostname -f
echo "/////////////////////"
_init_bind9_config

chown -R root:bind /var/cache/bind && chmod -R 770 /var/cache/bind
chown -R root:bind /etc/bind/ && chmod -R 775 /etc/bind

chown -R root:bind /etc/bind/* && chmod -R 770 /etc/bind/*
#chown root:bind /etc/bind/named.root
#chmod 640 /etc/bind/named.root

#chown root:bind /etc/bind/localhost.zone
#chmod 640 /etc/bind/localhost.zone

#chown root:bind /etc/bind/0.0.127.zone
#chmod 640 /etc/bind/0.0.127.zone

ls -all /etc/bind/

samba-tool domain provision --server-role=dc --use-rfc2307 --dns-backend=BIND9_DLZ --realm=FZEN.PRO --domain=FZEN --adminpass=Passw0rd

chmod 640 /var/lib/samba/private/dns.keytab
chown root:bind /var/lib/samba/private/dns.keytab

chmod 770 /var/lib/samba/bind-dns/
chown root:bind /var/lib/samba/bind-dns/


mv /etc/krb5.conf /etc/krb5.conf.back
cp /var/lib/samba/private/krb5.conf /etc/krb5.conf
chmod 640 /etc/krb5.conf
chown root:bind /etc/krb5.conf

samba_upgradedns --dns-backend=BIND9_DLZ

samba

#cat /etc/passwd

echo "Тест служб"
ps axf | egrep "samba|smbd|winbindd"
echo "/////////////////////"

cat /etc/default/named

/usr/sbin/named -f -c  "/etc/bind/named.conf" -u bind

#samba -i

#echo "Тест DNS"
#host -t SRV _ldap._tcp.fzen.pro.
#host -t SRV _kerberos._udp.fzen.pro.
#host -t A dc1.fzen.pro.
#echo "/////////////////////"

_init_ssh(){
        /usr/bin/ssh-keygen -A
        cp /.ssh/* /root/.ssh/
        chmod 640 /root/.ssh/id_rsa.pub
        chmod 600 /root/.ssh/id_rsa
        chmod 640 /root/.ssh/authorized_keys
        /etc/init.d/ssh start
}

#_init_ssh
# Нужно для входа без оболоччки
#echo "/usr/sbin/nologin" >> /etc/shells

#mkdir -p /var/share/empty
#chmod a-w /var/share/empty

#groupadd -r "ftp_users"
#chgrp ftp_users /share/
#chmod 3770 /share/
#mkdir /etc/vsftpd

#for i in $(cat /root/.users) ; do
#	echo "$i"
#	NAME=$(echo $i | cut -d'|' -f1)
#	GROUP=$NAME
#	PASS=$(echo $i | cut -d'|' -f2)
#	CHROOT=$(echo $i | cut -d'|' -f3)
#	UID_var=$(echo $i | cut -d'|' -f4)
#
#	echo "$NAME:$PASS" >> /credentials
#	chmod 600 /credentials
#
#	if [ ! -z "$UID_var" ]; then
#		UID_OPT="--uid=$UID_var"
#		if [ -z "$GID_var" ]; then
#			GID_var=$UID_var
#		fi
#	fi
#	# Поменять домашний каталог на /home/$NAME/ если нужна индивидуальная папка для каждого пользователя
#	# После чего создать каталог /home/$NAME/ftp с правами 0770 и владельцем $NAME:$NAME
#	useradd -r -M --home="/share/" -G "ftp_users" $UID_OPT -c "FTP $NAME" -p $(mkpasswd --method=SHA-512 --stdin "$PASS") --shell=/usr/sbin/nologin $NAME
#	echo "$NAME" >> /etc/vsftpd/user_list
#	if [ $CHROOT == "true" ]; then
#		echo "Пользователю $NAME доступен корневой каталог!"
#		echo "$NAME" >> /etc/vsftpd/chroot_list
#	else
#		echo "Пользователь $NAME ограничен домашним каталогом /share/!"
#		mkdir -p "/share/$NAME/"
#		chown $NAME "/share/$NAME/"
#		chmod 3770 "/share/$NAME/"
#	fi
#	unset NAME GROUP PASS CHROOT UID_var
#done
#vsftpd /etc/vsftpd.conf
