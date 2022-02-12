# コマンドライン引数のデフォルト値をセット
Param(
    [String]$Arg1 = "false", # imageをbuildするか
    [String]$Arg2 = "tcplara:1.0", # image名
    [String]$Arg3 = "tcplara3" # container名
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

$mount_folder_name = "laravel3_0_disk"
$mount_folder_dir = "C:\docker_files\" + $mount_folder_name

$mount_folder_name_tcp = "tcpserver"
$mount_folder_dir_tcp = "C:\docker_files\" + $mount_folder_name_tcp

if(test-path $mount_folder_dir)
{
    $str = $mount_folder_dir +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir -itemType Directory
}

$mount_folder_dir_app = $mount_folder_dir + "/app"
if(test-path $mount_folder_dir_app)
{
    $str = $mount_folder_dir_app +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir_app -itemType Directory
}

$mount_folder_dir_routes = $mount_folder_dir + "/routes"
if(test-path $mount_folder_dir_routes)
{
    $str = $mount_folder_dir_routes +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir_routes -itemType Directory
}

$mount_folder_dir_resources = $mount_folder_dir + "/resources"
if(test-path $mount_folder_dir_resources)
{
    $str = $mount_folder_dir_resources +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir_resources -itemType Directory
}

$mount_folder_dir_database = $mount_folder_dir + "/database"
if(test-path $mount_folder_dir_database)
{
    $str = $mount_folder_dir_database +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir_database -itemType Directory
}

$mount_folder_dir_public = $mount_folder_dir + "/public"
if(test-path $mount_folder_dir_public)
{
    $str = $mount_folder_dir_public +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir_public -itemType Directory
}

$mount_folder_dir_config = $mount_folder_dir + "/config"
if(test-path $mount_folder_dir_config)
{
    $str = $mount_folder_dir_config +  ' is already exits. so do not make directory newly.'
    Write-Output $str
}
else
{
    New-Item $mount_folder_dir_config -itemType Directory
}

docker container run `
 -it `
 -h $host_name `
 --name $container_name `
 -p 80:80 `
 -p 8081:8081 `
 -p 10306:3306 `
 -p 6379:6379 `
 --mount type=bind,src=$mount_folder_dir_tcp,dst=/root/windows_disk `
 --mount type=bind,src=$mount_folder_dir_app,dst=/var/www/canvas/app `
 --mount type=bind,src=$mount_folder_dir_routes,dst=/var/www/canvas/routes `
 --mount type=bind,src=$mount_folder_dir_resources,dst=/var/www/canvas/resources `
 --mount type=bind,src=$mount_folder_dir_database,dst=/var/www/canvas/database `
 --mount type=bind,src=$mount_folder_dir_public,dst=/var/www/canvas/public `
 --mount type=bind,src=$mount_folder_dir_config,dst=/var/www/canvas/config `
 $image_name