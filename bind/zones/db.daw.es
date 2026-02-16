$TTL 86400
@       IN SOA  ns1.daw.es. root.daw.es. (
                2024083001 ; Serial
                3600       ; Refresh
                1800       ; Retry
                1209600    ; Expire
                86400      ; Minimum TTL
                )

;
@       IN NS   ns1.daw.es.
ns1     IN A    10.1.0.10
www     IN A    10.1.0.20
despliegue IN A 10.1.0.20
www.despliegue IN A 10.1.0.20
www.despliegue.daw.es IN A 10.1.0.20