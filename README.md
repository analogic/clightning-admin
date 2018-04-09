C-Lightning admin
=================

Simple web administrator for C-Lightning. Admin is meant to be run in docker with access to RPC socket.

```
$ docker run --name cla \
    -v /data/cla/log:/var/log \
    -v /data/cla/app:/var/www/var/log \
    
```