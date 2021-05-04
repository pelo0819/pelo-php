$container_name = "pelo01"
$host_name = "pelo"
$image_name = "test:2.0"

$mount_folder_name = "ubuntu_disk"
$mount_folder_dir = "C:\" + $mount_folder_name
if(test-path $mount_folder_dir)
{
    $str = $mount_folder_dir +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir -itemType Directory
}

docker container run `
 -it `
 -h $host_name `
 --name $container_name `
 -p 10080:80 `
 -p 10306:3306 `
 --mount type=bind,src=/C/$mount_folder_name,dst=/root/windows_disk `
 $image_name /bin/bash