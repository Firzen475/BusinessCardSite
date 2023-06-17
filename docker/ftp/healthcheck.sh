#!/bin/bash

GROUP=$(getent group $GID_var | cut -d: -f1)
if [ -z "$GROUP" ]; then
	exit 1;
else
	exit 0;
fi
