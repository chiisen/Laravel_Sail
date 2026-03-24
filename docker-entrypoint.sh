#!/usr/bin/env bash

# 移除 Supervisor 中的 reverb 進程配置
# 因為 laravel/reverb 已被移除，但基礎映像中仍有此配置
if grep -q "\[program:reverb\]" /etc/supervisor/conf.d/supervisord.conf; then
    sed -i '/^\[program:reverb\]/,/^$/d' /etc/supervisor/conf.d/supervisord.conf
fi

# 執行原始啟動指令
exec /usr/local/bin/start-container "$@"
