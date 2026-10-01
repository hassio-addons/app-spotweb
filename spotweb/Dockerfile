ARG BUILD_FROM=ghcr.io/hassio-addons/base:21.0.7
# hadolint ignore=DL3006
FROM ${BUILD_FROM}

# Set shell
SHELL ["/bin/bash", "-o", "pipefail", "-c"]

# Setup base
# Spotweb has not tagged a release since 1.5.8 (December 2024) and its master
# branch has been dormant since February 2025. All development happens on the
# develop branch, so we track that, pinned to an exact commit for reproducible
# builds. Renovate bumps the digest.
ARG SPOTWEB_VERSION="412993dda5de9cc34e524ff816d18d74be493c05"
RUN \
    apk add --no-cache \
        nginx=1.30.4-r1 \
        php84-ctype=8.4.26-r0 \
        php84-curl=8.4.26-r0 \
        php84-dom=8.4.26-r0 \
        php84-fileinfo=8.4.26-r0 \
        php84-fpm=8.4.26-r0 \
        php84-gd=8.4.26-r0 \
        php84-gettext=8.4.26-r0 \
        php84-gmp=8.4.26-r0 \
        php84-iconv=8.4.26-r0 \
        php84-intl=8.4.26-r0 \
        php84-mbstring=8.4.26-r0 \
        php84-opcache=8.4.26-r0 \
        php84-openssl=8.4.26-r0 \
        php84-pdo=8.4.26-r0 \
        php84-pdo_sqlite=8.4.26-r0 \
        php84-session=8.4.26-r0 \
        php84-simplexml=8.4.26-r0 \
        php84-xml=8.4.26-r0 \
        php84-xmlreader=8.4.26-r0 \
        php84-xmlwriter=8.4.26-r0 \
        php84-zip=8.4.26-r0 \
        php84=8.4.26-r0 \
    \
    && mkdir -p /var/www/spotweb \
    && curl -J -L -o /tmp/spotweb.tar.gz \
        "https://github.com/spotweb/spotweb/archive/${SPOTWEB_VERSION}.tar.gz" \
    && tar zxf /tmp/spotweb.tar.gz -C \
        /var/www/spotweb --strip-components=1 \
    \
    && find /var/www/ -type f -name "*.md" -depth -exec rm -f {} \; \
    && rm -f -r \
        /etc/nginx \
        /tmp/* \
        /var/www/spotweb/.github \
        /var/www/spotweb/.travis.yml \
        /var/www/spotweb/composer.json \
        /var/www/spotweb/composer.lock \
        /var/www/spotweb/phpunit.xml.dist

# Copy root filesystem
COPY rootfs /

# Build arguments
ARG BUILD_ARCH
ARG BUILD_DATE
ARG BUILD_DESCRIPTION
ARG BUILD_NAME
ARG BUILD_REF
ARG BUILD_REPOSITORY
ARG BUILD_VERSION

# Labels
LABEL \
    io.hass.name="${BUILD_NAME}" \
    io.hass.description="${BUILD_DESCRIPTION}" \
    io.hass.arch="${BUILD_ARCH}" \
    io.hass.type="addon" \
    io.hass.version=${BUILD_VERSION} \
    maintainer="Franck Nijhof <opensource@frenck.dev>" \
    org.opencontainers.image.title="${BUILD_NAME}" \
    org.opencontainers.image.description="${BUILD_DESCRIPTION}" \
    org.opencontainers.image.vendor="Home Assistant Community Apps" \
    org.opencontainers.image.authors="Franck Nijhof <opensource@frenck.dev>" \
    org.opencontainers.image.licenses="MIT" \
    org.opencontainers.image.url="https://frenck.dev/home-assistant-apps" \
    org.opencontainers.image.source="https://github.com/${BUILD_REPOSITORY}" \
    org.opencontainers.image.documentation="https://github.com/${BUILD_REPOSITORY}/blob/main/README.md" \
    org.opencontainers.image.created=${BUILD_DATE} \
    org.opencontainers.image.revision=${BUILD_REF} \
    org.opencontainers.image.version=${BUILD_VERSION}
