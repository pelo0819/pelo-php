$container_name = "pelo08"
$host_name = "pelo"
$image_name = "ubuntu:pelo_apache2_3"

docker container run `
 -it `
 -h $host_name `
 --name $container_name `
 -p 127.0.0.1:10080:80 `
 --mount type=bind,src=/C/Users/tobita/docker_mount,dst=/root/windows_disk `
 $image_name /bin/bash