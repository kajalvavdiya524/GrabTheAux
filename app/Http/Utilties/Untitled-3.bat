git@github.com:Alpha-Bravo-Development/GrabTheAux.git

git remote add origin https://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@github.com/Alpha-Bravo-Development/GrabTheAux.git/
You already know that every remote stores a URL: origin literally means https://<username>:<AccessToken>@<domain>/<owner>/<reponame>.git/.

What you didn't know is that every remote actually stores two URLs. One is used for git fetch, and the second one is used for push. The second URL defaults to being the same as the first URL, but if you set it, you can set it to anything else, such as the URL without the access token. To set the second URL, you can use git remote set-url --push:

git remote set-url --push origin https://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@github.com/Alpha-Bravo-Development/GrabTheAux.git
