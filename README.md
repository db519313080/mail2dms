
### 监控发件人及主题，并转接到 dms 上

使用方法见 test.php

### 使用 supervisor

```
[program: email2dms]
process_name=%(program_name)s
command=php test.php
stderr_logfile=/var/log/email2dms.err.log
stdout_logfile=/var/log/email2dms.out.log
autostart=true
autorestart=true
startsecs=2
numprocs=1

```