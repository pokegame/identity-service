# Pokegame - Identity service

This provides endpoints for signup and login.

## Configuration

Generate the SSH keys with:

```
$ make generate-jwt-keys
```

## Service API

### POST /signup

With body:

```
{
    "email": "jon.snow@stark.io",
    "password": "watch"
}
```

On success will respond with a `201` status code:

```
{
    "success": true,
    "message": "User created."
}
```

### POST /signin

With body:

```
{
    "email": "jon.snow@stark.io",
    "password": "watch"
}
```

If the credentials are correct, it will respond with an authentication token:

```
{
    "token": "eyJhbGciOiJ..."
}
```

### GET /public-key

It will responds with the server's public key. You can use this to verify signed JWT:

```
{
    "publicKey": "..."
}
```
