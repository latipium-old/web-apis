#!/bin/bash
set -e

# Only build on the master branch
if [ "$TRAVIS_PULL_REQUEST" != "false" ] || [ "$TRAVIS_BRANCH" != "master" ]; then
  echo "Skipping deploy."
  exit 0
fi

# Decrypt private data
openssl aes-256-cbc -K $encrypted_9329eebe91f4_key -iv $encrypted_9329eebe91f4_iv -in src/lib/private.php.enc -out src/lib/private.php -d
openssl aes-256-cbc -K $encrypted_b68dbcd8babf_key -iv $encrypted_b68dbcd8babf_iv -in deploy.ftp.enc -out deploy.ftp -d

# Remove unneccessary files
rm -f src/lib/{.gitignore,private.php.enc}

# Upload sources
lftp -f deploy.ftp
