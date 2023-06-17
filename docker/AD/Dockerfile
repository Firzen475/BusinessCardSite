FROM ubuntu:20.04 as ad

# Переменные
ARG TZ=Europe/Moscow
ENV TZ $TZ
ARG LANG=en_US
ENV LANG $LANG
ENV LANGUAGE $LANG

ARG DOMAIN=example.lan
ENV DOMAIN $DOMAIN

RUN echo $DOMAIN
#Установка локали
RUN set -eux; \
        apt update && apt-get install -yq --no-install-recommends locales
RUN echo $LANG
RUN ls -all /usr/share/locale/
RUN      localedef -i $LANG -c -f UTF-8 -A /usr/share/locale/locale.alias $LANG.UTF-8 \
        && apt install -yq  tzdata
ENV LANG $LANG.utf8
ENV LANGUAGE $LANG

RUN set -eux; \
	apt update && apt -y install  bind9 bind9utils net-tools iputils-ping \
	&& sed -i -r "s:OPTIONS=\"-u bind\":OPTIONS=\"-u bind -4\":" /etc/default/named

# Now remove the pkexec that got pulled as dependency to software-properties-common
RUN apt-get --purge -y autoremove policykit-1

RUN mkdir -p /etc/bind && chown root:bind /etc/bind/ && chmod 775 /etc/bind
RUN mkdir -p /var/cache/bind && chown bind:bind /var/cache/bind && chmod 755 /var/cache/bind
RUN mkdir -p /var/lib/bind && chown bind:bind /var/lib/bind && chmod 755 /var/lib/bind
RUN mkdir -p /var/log/bind && chown bind:bind /var/log/bind && chmod 755 /var/log/bind
RUN mkdir -p /run/named && chown bind:bind /run/named && chmod 755 /run/named

VOLUME ["/etc/bind", "/var/cache/bind", "/var/lib/bind" ]

#EXPOSE 53/udp 53/tcp 953/tcp



#Установка bind и samba AD
RUN set -eux; \
	apt update && apt -y install acl attr samba samba-dsdb-modules samba-vfs-modules smbclient winbind libpam-winbind libnss-winbind libpam-krb5 krb5-config krb5-user dnsutils chrony net-tools 
RUN mv /etc/samba/smb.conf /etc/samba/smb.conf.back
#RUN samba-tool domain provision --server-role=dc --use-rfc2307 --dns-backend=BIND9_DLZ --realm=FZEN.PRO --domain=FZEN --adminpass=Passw0rd
#	&& unlink /etc/resolv.conf \
#	&& echo "nameserver $(hostname  -I | cut -f1 -d' ')" >> /etc/resolv.conf \
#	&& echo "nameserver 1.1.1.1" >> /etc/resolv.conf \
#	&& echo "search $DOMAIN" >> /etc/resolv.conf \
#	&& sudo chattr +i /etc/resolv.conf

COPY entrypoint.sh /usr/local/bin/
COPY named.conf.options /named.conf.options
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN apt -y install tcpdump

EXPOSE 53/udp 53/tcp 953/tcp 88 135 139 445 636 9389 3268 3269 389 636

#COPY hostname /ets/hostname

#VOLUME /share/ /.ssh/ /root/ssl/

#COPY entrypoint.sh healthcheck.sh .users /root/
#COPY vsftpd.conf /etc/vsftpd.conf

#RUN chmod +x /root/entrypoint.sh \
#	&& chmod +x /root/healthcheck.sh
#EXPOSE 20 21
ENTRYPOINT ["entrypoint.sh"]



