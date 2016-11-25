#!/bin/bash
set -e

# Only build on the master branch
if [ "$TRAVIS_PULL_REQUEST" != "false" ] || [ "$TRAVIS_BRANCH" != "master" ]; then
	echo "Skipping deploy."
	exit 0
fi

# Set up directories
cat <<exit | sshpass -fpass ssh -F config deployserver
cd /var/lib/fusionforge/chroot/home/groups/latipium/
if [ -d src ]; then
    rm -rf src
fi
mkdir src
exit

# Upload the code
tar c $(find src -type f) | sshpass -fpass ssh -F config deployserver "tar xC /var/lib/fusionforge/chroot/home/groups/latipium/"

# Swap code versions
cat <<exit | sshpass -fpass ssh -F config deployserver
cd /var/lib/fusionforge/chroot/home/groups/latipium/
if [ -d htdocs.old ]; then
    rm -rf htdocs.old
fi
chmod 640 \$(find src -type f)
chmod 751 \$(find src -type d)
mv htdocs htdocs.old
mv src htdocs
rm -rf htdocs.old
exit

# Finished
echo "Deploy successful."
