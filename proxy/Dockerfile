FROM httpd:2.4.68

# =========================================================
# mod_evasive for Apache 2.4
# =========================================================

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        gcc \
        make \
        curl \
        libapr1-dev \
        libaprutil1-dev \
    && curl -L \
        https://github.com/shivaas/mod_evasive/archive/refs/heads/master.tar.gz \
        -o /tmp/mod_evasive.tar.gz \
    && tar -xzf /tmp/mod_evasive.tar.gz -C /tmp \
    && cd /tmp/mod_evasive-master \
    && /usr/local/apache2/bin/apxs \
        -i -a -c mod_evasive24.c \
    && apt-get purge -y \
        gcc \
        make \
        libapr1-dev \
        libaprutil1-dev \
    && apt-get autoremove -y \
    && rm -rf \
        /var/lib/apt/lists/* \
        /tmp/mod_evasive*

# =========================================================
# Reverse Proxy modules
# =========================================================

RUN sed -i \
    -e 's/^#LoadModule proxy_module/LoadModule proxy_module/' \
    -e 's/^#LoadModule proxy_http_module/LoadModule proxy_http_module/' \
    /usr/local/apache2/conf/httpd.conf \
    && echo "Include conf/extra/reverse-proxy.conf" \
    >> /usr/local/apache2/conf/httpd.conf

COPY httpd.conf /usr/local/apache2/conf/extra/reverse-proxy.conf
