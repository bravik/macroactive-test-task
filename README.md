# Test task for Macroacive

Run on docker with docker compose:
```shell
make init   # First time run (init db)
make test   # Run tests
make up     # Run docker container for manual testing
```

Accepts JSON requests with `Content-Type: application-json`:

* `POST /add` - Add message  
    I've changed the body structure a bit:
    ```json
    {
        "authorEmail": "naumeno_subscr@mail.ru",
        "content": "yo man!",
        "isPublished": 0
    }
    ```
* `GET /`  
* `GET /leaderboard`

Project doesn't reflect DDD in its folder structure  
but has clear DDD context and layer boundaries.


# An original task:
## Home trial for back-end applicants

Your application should be considered as a part of a big project, so don't use simple scripts and consider using a proper framework (of your choice though).
No need to try to introduce any optimizations in advance, the idea of the task is to make an example of your very best code with the very best design/architecture.
Tests are required. Front-end will not be considered.

### Description of the app

No authentication is required — all actions can be done by guests. You need to add ability to add a message, show all messages, show leaderboard of most active authors.

### Requirements:

* app can be ran using PHP7.4
* every posted message has: `content` which can contain any text, `author` field of email format and status `published/draft`
* next pages are required:
    * `/` is the index page showing all published messages
    * `/add` is the page to add a message having three fields: `content`, `author`, and `status` flag/checkbox
    * `/leaderboard` is a list of top-10 authors (published messages counted only) and top-10 writers (status is not accounted)

You can implement pages either as server-generated html or as API endpoints. Using DDD/CQRS is appreciated.