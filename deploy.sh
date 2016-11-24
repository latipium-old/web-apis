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
if [ -d htdocs.new ]; then
    rm -rf htdocs.new
fi
mkdir htdocs.new
exit

# Upload the code
sshpass -fpass scp -r src/* -F config deployserver:/var/lib/fusionforge/chroot/home/groups/latipium/htdocs.new/

# Swap code versions
cat <<exit | sshpass -fpass ssh -F config deployserver
cd /var/lib/fusionforge/chroot/home/groups/latipium/
if [ -d htdocs.old ]; then
    rm -rf htdocs.old
fi
mv htdocs htdocs.old
mv htdocs.new htdocs
rm -rf htdocs.old
exit

# Finished
echo "Deploy successful."
