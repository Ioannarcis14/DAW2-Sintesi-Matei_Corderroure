# PickEat

PickEat is an web and phone aplication, that gives the possibility to restaurants to show themself to the public by being discharged in the app.



## Deployment

### For Windows:

1.- Clone the repository
If you don't want to download the zip File:

```
git clone https://github.com/Ioannarcis14/DAW2-Sintesi-Matei_Corderroure.git
```
2.- Open your CMD or terminal environment of choice and on the repository path type in:

```
docker-compose up
```
**be sure to have nothing running on port 3306 or 80**

3.- While the CMD/terminal is **running** the container open another CMD for enter inside the following container and make the database information create/generate. So type in the following commands:

```
docker exec -it codeigniter41 /bin/bash
```
```
php spark migrate
```
```
php spark db:seed Install
```
Now you should have it all ready.



### For Linux:

1.- Clone the repository
Open a terminal and type in on your wanted path:

```
git clone https://github.com/Ioannarcis14/DAW2-Sintesi-Matei_Corderroure.git
```
2.- Ensure that your ports 80 and 3306 are not binded to seomthign
In most cases Apache and mysql should be the problem to it, use this commands if it's the case

```
sudo systemctl stop apache2
```
and/or
```
sudo service mysql stop
```

3.- Be sure the folder "writable" on www/DAW2-Sintesi-Matei-Corderroure/ has read-write permissions

```
sudo chmod -R 777 www/DAW2-Sintesi-Matei-Corderroure
```

4.- On the root path of the repository write this command to run the web docker-container:
```
sudo docker-compose up
```
5.- While the CMD/terminal is **running** the container open another CMD for enter inside the following container and make the database information create/generate. So type in the following commands:

```
sudo docker exec -it codeigniter41 /bin/bash
```
```
php spark migrate
```
```
php spark db:seed Install
```
