C-Lightning admin
=================

Simple web administrator for C-Lightning. Admin is meant to be run in docker with access to RPC socket. 

### Running regnet with two nodes for testing

```
$ docker-compose -f docker-compose.regnet.yml up
```
- administration of node1: https://localhost:5080 - user *admin*, password *admin*
- administration of node2: https://localhost:5081 - user *admin*, password *admin*

### Running mainnet package

TODO