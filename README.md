[![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/cima-alfa/docker-web-development)

# Docker Web Dev Preset

## Create a new project from this template repository

```shell
gh repo create my-new-project --template cima-alfa/docker-web-development --clone --private|public|internal
```

or just clone it without creating a new repository...

```shell
gh repo clone cima-alfa/docker-web-development my-new-project
```

or

```shell
git clone https://github.com/cima-alfa/docker-web-development.git my-new-project
```

## Commands

A simple shell script is included, located in the `/bin` directory (`./bin/app ...`), to run basic Docker CLI commands:

| Command                               | Description                 |
|---------------------------------------|-----------------------------|
| `app up [<container>] [-d] [--build]` | Start / Build container(s). |
| `app stop [<container>]`              | Stop container(s).          |
| `app restart [<container>]`           | Restart container(s).       |
| `app down [<container>] [-v]`         | Remove container(s).        |
| `app sh <container>`                  | Access container shell.     |

For example:

- `app up ...` executes `docker compose --env-file=./.docker/.env up ...`
- `app sh <container>` executes `docker exec -it <container> sh`

### TIP: Executing the `app` shell script

Instead of writing `bin/app ...` or `../bin/app ...`, you can create a global alias / function that executes the script for the current project.

For example, if we have our projects in the `~/projects` directory, we can export the following function in our `~/.bashrc` or `~/.bash_aliases` file:

```shell
function app()
{
        project=$(echo "$PWD" | grep -oP "^$HOME/projects/[^/]+/?")

        if [ "$project" == "" ]; then
                printf "You are not located in a project directory...\n"

                return
        fi

        cmd="${project%/}/bin/app"

        eval "$cmd ${@}"

        return
}

export -f app
```

Now, if we execute the `app ...` command, it will automatically find the correct `~/projects/<current-project>/bin/app` shell script.

Don't forget to modify the path to your projects directory based on your structure. Of course, if the `app` function name is too generic, you can change it to your liking.

### Containers

- `web-server` (Apache 2 Alpine)
- `application` (PHP 8.4 FPM Alpine, Node.js Latest - Optional)
- `mail` (Mailpit Latest)
- `database` (MySQL 8.4)
- `cache` (Redis 7.4 Alpine)
- `adminer` (Adminer Latest)
