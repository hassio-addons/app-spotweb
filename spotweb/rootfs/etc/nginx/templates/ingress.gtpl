server {
    listen {{ .interface }}:8099 default_server;

    include /etc/nginx/includes/server_params.conf;

    allow   172.30.32.2;
    deny    all;

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_read_timeout 900;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        # Spotweb renders an absolute <base href> and derives it from these
        # three. Home Assistant sends the first two; the ingress path arrives
        # as X-Ingress-Path, which Spotweb reads under its own name. Without
        # them every relative link and asset would resolve against the root of
        # the Home Assistant host instead of the ingress entry point.
        fastcgi_param HTTP_HOST $http_x_forwarded_host if_not_empty;
        fastcgi_param HTTP_X_FORWARDED_PROTO $http_x_forwarded_proto if_not_empty;
        fastcgi_param HTTP_X_FORWARDED_URI $http_x_ingress_path if_not_empty;

        include /etc/nginx/includes/fastcgi_params.conf;
    }
}
