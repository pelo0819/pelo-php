# コマンドライン引数のデフォルト値をセット
Param(
    [String]$Arg1 = "false", # imageをbuildするか
    [String]$Arg2 = "apache:1.0", # image名
    [String]$Arg3 = "apache01" # container名
)

$host_name = "pelo"
$image_name = $Arg2
$container_name = $Arg3

docker container rm $Arg3

if($Arg1 -eq "true")
{
    $str = "[*] attempt to delete image " + $Arg2 + " ."
    docker image rm $Arg2
    $str = "[*] build new image " + $Arg2 + " ." 
    Write-Host $str
    docker build -t $Arg2 .
}

$mount_folder_name = "apache1_0_disk"
$mount_folder_dir = "C:\docker_files\" + $mount_folder_name
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
 -p 80:80 `
 --mount type=bind,src=$mount_folder_dir,dst=/root/windows_disk `
 $image_name /bin/bash