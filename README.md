C-Lightning admin
=================

Simple web administrator for C-Lightning. Admin is meant to be run in docker with access to RPC socket. 

Administration uses environment variables for initial settings:

| Variable      | Description  |
| ------------- |-----|
| PASSWORD      | Password to login into administration (default **admin**) |
| CLIGHTNING_RPC_SOCKET | Location of CLightning (default **unix:///root/.lightning/lightning-rpc**), it is supposed to be included via volume. For remote socket you should use **tcp://remote.host.example:9835** |
| BITCOIND_RPC_DSN | Location of Bitcoind RPC. It is not required but administration can send and generate addresses for simple onchain transactions; example: **http://bitcoinrpc:rpcpassword@remote.host.example:18332** |
| APP_ENV | prod/dev - *dev* enables symfony debug toolbar |

### Running regnet with two nodes for testing and developing

see *[docker-compose.dev.yml](https://github.com/analogic/clightning-admin/blob/master/docker-compose.dev.yml)*

```
$ git clone https://github.com/analogic/clightning-admin.git
...
$ cd clightning-admin
$ docker-compose -f docker-compose.dev.yml up
```
- administration of node1: https://localhost:5080 - user *admin*, password *admin*
- administration of node2: https://localhost:5081 - user *admin*, password *admin*

### Running testnet

see *[docker-compose.testnet.yml](https://github.com/analogic/clightning-admin/blob/master/docker-compose.testnet.yml)*

```
$ wget https://raw.githubusercontent.com/analogic/clightning-admin/master/docker-compose.dev.yml
...
$ docker-compose -f docker-compose.testnet.yml up
```

### Running mainnet

see *[docker-compose.mainnet.yml](https://github.com/analogic/clightning-admin/blob/master/docker-compose.mainnet.yml)*

```
$ wget https://raw.githubusercontent.com/analogic/clightning-admin/master/docker-compose.mainnet.yml
...
$ docker-compose -f docker-compose.mainnet.yml up
```