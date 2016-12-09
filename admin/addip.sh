#!/bin/bash
sudo /sbin/iptables -A INPUT -s $1 -j ACCEPT;

