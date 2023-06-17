FROM ubuntu:20.04

LABEL maintainer="firzen475@gmail.com"
LABEL version="0.1"
LABEL description="Container for manage servers"

ARG DEBIAN_FRONTEND=noninteractive #remove config query

ENV FIRST_START=true
ENV HTTP_PORT=80
ENV HTTPS_PORT=443
ENV HTTPS_PORT_TEST_1=444
ENV HTTPS_PORT_TEST_2=445
ENV HTTPS_PORT_TEST_3=446
#ENV TEST=DEFAULT_TEST
#ENV TECT_SECRET_1=DEFAULT_TECT_SECRET_1
#ENV TECT_SECRET_2=DEFAULT_TECT_SECRET_2

#RUN echo $TZ_DEFAULT >> /etc/timezone

ARG TZ=Europe/Moscow
ENV TZ $TZ
ARG LANG=en_US
ENV LANG $LANG
ENV LANGUAGE $LANG

#Установка локали
RUN set -eux; \
        apt update && apt-get install -yq --no-install-recommends locales && \
        localedef -i $LANG -c -f UTF-8 -A /usr/share/locale/locale.alias $LANG.UTF-8 && \
        apt install -yq  tzdata
ENV LANG $LANG.utf8
ENV LANGUAGE $LANG


RUN set -eux; \
	apt update && apt install -y apache2 php php-pgsql libapache2-mod-php openssh-client sudo\
	&& find /etc/php/ -name php.ini -exec sh -c "echo 'file_uploads = On'  >> {}" \; \
	&& find /etc/php/ -name php.ini -exec sh -c "echo 'extension=openssl' >> {}" \; \
	&& a2enmod proxy \
	&& a2enmod proxy_http \
	&& a2enmod proxy_ajp \
	&& a2enmod rewrite \
	&& a2enmod deflate \
	&& a2enmod headers \
	&& a2enmod proxy_balancer \
	&& a2enmod proxy_connect \
	&& a2enmod proxy_html \
	&& rm -rf /var/lib/apt/lists/* \
	&& apt-get clean \
	&& chown -R www-data:www-data /var/www/html \
	&& mkdir -p /etc/ssl/common \
	&& mkdir -p /share/ \
        && mkdir -p /mnt/NFS \
	&& mkdir -p /.ssh/ \
	&& mkdir -p /root/.ssh/

#Настройка credentials через sudo
RUN echo "www-data   ALL= NOPASSWD: /bin/bash /pg_credentials.sh" >> /etc/sudoers; \
	echo "www-data   ALL= NOPASSWD: /bin/bash /ftp_credentials.sh" >> /etc/sudoers; \
	echo "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no root@pgsql -i /root/.ssh/id_rsa 'cat /credentials'" >> /pg_credentials.sh; \
	echo "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no root@pgadmin -i /root/.ssh/id_rsa 'cat /credentials'" >> /pg_credentials.sh; \
	echo "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no root@ftp -i /root/.ssh/id_rsa 'cat /credentials'" >> /ftp_credentials.sh; \
	chmod +x /pg_credentials.sh; \
	chmod +x /ftp_credentials.sh

#CMD ["ls", "-all", "/mnt/NFS"]
#RUN chown -R www-data:www-data /mnt/NFS/dst
#CMD ["ls", "-all", "/mnt/NFS"]
#RUN chmod -R 775 /mnt/NFS/dst
#RUN mkdir -p /var/www/html/resource/
#RUN ln -s /mnt/NFS/dst /var/www/html/resource/dst

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
COPY ./main_http.conf ./main_https.conf /etc/apache2/sites-available/ 
COPY ./ports.conf /etc/apache2/
#RUN a2enmod ssl && a2enmod rewrite && a2ensite main_http.conf && a2ensite main_https.conf && \
#a2dissite 000-default.conf && a2dissite default-ssl.conf && service apache2 restart

VOLUME ["/etc/ssl/common/", "/var/log/apache2", "/var/www/html", "/share/", "/mnt/NFS". "/.ssh/" ]

EXPOSE 80 81 82 83 443 444 445 446

ENTRYPOINT ["entrypoint.sh"]

#CMD ["ls", "-all", "/usr/bin"]
#CMD ["cat", "/etc/apache2/sites-available/000-default.conf"]

#RUN echo $TZ_DEFAULT >> /etc/1

#RUN echo $TEST >> /etc/1
#RUN echo $TECT_SECRET_1 >> /etc/1
#RUN echo $TECT_SECRET_2 >> /etc/1

#RUN echo $TZ >> /etc/1

#CMD ["cat", "/etc/apache2/ports.conf"]

#ENTRYPOINT ["echo", "" ]

#CMD ["/bin/bash", "/etc/start.sh"]

#CMD ["apachectl", "-D", "FOREGROUND"]
