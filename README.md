
# HelloCSE Technical Assessment

This project is a technical test by HelloCSE in order to join the team as a Lead Backend.


## API Reference

#### Login

```http
  POST /api/v1/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email`   | `string` | **Required**. Your email   |
| `password`| `string` | **Required**. Your password|

#### Get logged admin infos

```http
  GET /api/v1/user
```


#### Logout

```http
  POST /api/v1/logout
```

#### Profiles List

```http
  GET /api/v1/profiles
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `perPage`   | `integer` | **optional**. Profiles per page (BONUS)  |

#### Create Profile

```http
  POST /api/v1/profiles
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`   | `string` | **Required**. Profile name |
| `first_name`   | `string` | **Required**. Profile  first name |
| `status`   | `string` | **Required**. Profile status (actif,en attente,inactif) |
| `image`   | `image file` | **Required**. Profile image |

#### Edit Profile

```http
  PUT /api/v1/profiles/[id]
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`   | `string` | **Optional**. Profile name |
| `first_name`   | `string` | **optional**. Profile  first name |
| `status`   | `string` | **optional**. Profile status (actif,en attente,inactif) |
| `image`   | `image file` | **optional**. Profile image |

#### Delete Profile

```http
  DELETE /api/v1/profiles/[id]
```

#### Comment a Profile

```http
  POST /api/v1/profiles/[id]/comments
```

| Parameter | Type     | Description                   |
| :-------- | :------- | :-------------------------    |
| `content` | `string` | **Required**. comment content |

## Running Tests

To run tests, run the following command

```bash
  php artisan test
```

PS: Make sure you created a database for testing

## Running Static code analyzer

To run Duster, run the following command

To lint:

```bash
  ./vendor/bin/duster lint
```

To fix:

```bash
  ./vendor/bin/duster fix
```
## Recommendations / BONUS

Here are some recommendations that can be done on this project:

- The login is **based on JWT**.
- **Using Repository** (as I did in the ``profileController@index``) for better code re-usability and maintenability (insure that we are implementing DRY principles)
- I have implemented a custom builder to get active profiles. See ``app/Builders/ProfileBuilder.php`` for more details
- **I have used Enums** (file at ``app/Enums/StatusEnum.php``) to manage status.
- I have used **Resources to transform data according to the request issuer role (Admin or Guest)**
- I have added **a very powerful static code analyzer** using Tlint, PHP_CodeSniffer, PHP CS Fixer & Pint combined to ensure that we are delivering a robust code.
- I have added **a github Actions pipeline** the check code quality using to tools mentioned above. Be awere git blame can be generated if your code is not as good as expected. See PR #1 to see the result.
- **Better use User<->Roles instead of 1 model named Admin** to ensure code simplicity (Implement KISS principles in here)
- I have added **docker configuration** check ``Docker-compose.yml`` using laravel-sail for better development env and better DX. 



## Feedback

If you have any feedback, please reach out to me at lassad.kefi9010@gmail.com

