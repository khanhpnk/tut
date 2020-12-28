composer require cweagans/composer-patches
composer require psr/log

cd vendor/psr/log
git init .
git add -A .
git commit -m "Adding files to create diff"
# Changes to the LogLevel.php file and then proceed
git add -A .
git commit -m "Commit explaining the changes contained in the patch"
git format-patch -1 HEAD
rm -rf .git


    "extra": {
        "composer-exit-on-patch-failure": true,
        "patches": {
            "psr/log": {
                "GITHUB-9139: Unable to save": "patches/github-issue-1.patch"
            }
        }
    }

    "autoload": {
        "psr-4": {
            "Psr\\Log\\": "lib/psr/log/Psr/Log"
        }
    },