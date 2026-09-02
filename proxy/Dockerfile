FROM httpd:2.4.68

RUN sed -i \
    -e 's/^#LoadModule proxy_module/LoadModule proxy_module/' \
    -e 's/^#LoadModule proxy_http_module/LoadModule proxy_http_module/' \
    /usr/local/apache2/conf/httpd.conf \
    && echo "Include conf/extra/reverse-proxy.conf" \
    >> /usr/local/apache2/conf/httpd.conf

COPY httpd.conf /usr/local/apache2/conf/extra/reverse-proxy.conf
