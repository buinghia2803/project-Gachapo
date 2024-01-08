### **RELIPA Laravel source code base**

**Development environment installation guide.**

**Requrie:**  Docker and docker compose installed.

1.Get the project source code to the computer.

2.Move into the `docker` folder and run the following command:

`docker-compose build`

and wait for the process to complete.

3.Run the following command to start the project's docker container:

`docker-compose up -d`

and wait for the process to complete.

4.After running, move to the workspace container with the following command:

`docker-compose exec workspace bash`

After moving in, run the following command to install vendor:

`php composer.phar install`

5.Copy the `.env.example` file to `.env`

6.Path of basic screens:

EndUser screen: `http://localhost`

Admin screen: `http://localhost/admin`

Admin login account: `admin@example.com / Gachapo123`

Database screen: `http://localhost:9000`

`Server: mysql`

`Username: root`

`Password: root`

<!-- google drive config -->
FILESYSTEM_CLOUD=google
GOOGLE_DRIVE_CLIENT_ID=889181649957-g6ujaiig0k8nabd368uickgjg6cvrgt8.apps.googleusercontent.com
GOOGLE_DRIVE_CLIENT_SECRET=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
GOOGLE_DRIVE_REFRESH_TOKEN=1//04auhwv8iTZO-CgYIARAAGAQSNwF-L9IrLBMFIHLgqgmVAjvPvFbF2-KnsyHwtzPcXVlamwqq1lw0gABWrjYxoWSw9R66guGdi8M
GOOGLE_DRIVE_FOLDER_ID=1BNe2VwbVsoS_W-0MiFp1N__icP6FSFKX

<!-- vào docker và chạy lếnh sau để cập nhật đa ngôn ngữ -->
php artisan lang:generate resources/lang/labels.xlsx
php artisan lang:generate resources/lang/messages.xlsx

API Document
`php artisan l5-swagger:generate`
