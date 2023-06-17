#!/usr/bin/env bash

_init_ssh(){
        /usr/bin/ssh-keygen -A
        cp /.ssh/* /root/.ssh/
        chmod 640 /root/.ssh/id_rsa.pub
        chmod 600 /root/.ssh/id_rsa
        chmod 640 /root/.ssh/authorized_keys
        /etc/init.d/ssh start
}

_init_ssh
# Нужно для входа без оболоччки
echo "/usr/sbin/nologin" >> /etc/shells

mkdir -p /var/share/empty
chmod a-w /var/share/empty

groupadd -r "ftp_users"
chgrp ftp_users /share/
chmod 3770 /share/
mkdir /etc/vsftpd

for i in $(cat /root/.users) ; do
	echo "$i"
	NAME=$(echo $i | cut -d'|' -f1)
	GROUP=$NAME
	PASS=$(echo $i | cut -d'|' -f2)
	CHROOT=$(echo $i | cut -d'|' -f3)
	UID_var=$(echo $i | cut -d'|' -f4)

	echo "$NAME:$PASS" >> /credentials
	chmod 600 /credentials

	if [ ! -z "$UID_var" ]; then
		UID_OPT="--uid=$UID_var"
		if [ -z "$GID_var" ]; then
			GID_var=$UID_var
		fi
	fi
	# Поменять домашний каталог на /home/$NAME/ если нужна индивидуальная папка для каждого пользователя
	# После чего создать каталог /home/$NAME/ftp с правами 0770 и владельцем $NAME:$NAME
	useradd -r -M --home="/share/" -G "ftp_users" $UID_OPT -c "FTP $NAME" -p $(mkpasswd --method=SHA-512 --stdin "$PASS") --shell=/usr/sbin/nologin $NAME
	echo "$NAME" >> /etc/vsftpd/user_list
	if [ $CHROOT == "true" ]; then
		echo "Пользователю $NAME доступен корневой каталог!"
		echo "$NAME" >> /etc/vsftpd/chroot_list
	else
		echo "Пользователь $NAME ограничен домашним каталогом /share/!"
		mkdir -p "/share/$NAME/"
		chown $NAME "/share/$NAME/"
		chmod 3770 "/share/$NAME/"
	fi
	unset NAME GROUP PASS CHROOT UID_var
done
vsftpd /etc/vsftpd.conf
