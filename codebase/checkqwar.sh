checkqwarjs=$(ps ax | grep 'qwar.js'| awk '{print $1, $5}' | grep 'node' | awk '{print $1}')
if [ -z "$checkqwarjs" ]; then
    node /home/indr4winata/Workspaces/nodejs/qwar/qwar.js 1>/dev/null 2>&1 &
fi