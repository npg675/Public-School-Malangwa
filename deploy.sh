#!/usr/bin/env bash
set -euo pipefail
# sps_school — cPanel shared hosting deploy
# Repo: https://github.com/devbaratnp/sps_school.git
# Place this file in repo root. Webhook and cPanel Git both use it.
#
# One-time server setup:
#   cd ~/repositories
#   GIT_SSH_COMMAND="ssh -i ~/.ssh/github_repo -o StrictHostKeyChecking=no" \
#     git clone git@github.com:devbaratnp/sps_school.git
# Then create webhook secret in ~/repositories/sps_school/webhook.php

REPO_NAME="sps_school"
REPO_DIR="$HOME/repositories/$REPO_NAME"
HTML_DIR="$HOME/public_html"
BACKUP_DIR="$HOME/deploy-backups"
BRANCH="main"                           # production branch — change to feat/cms-content-blocks if you deploy that
SSH_KEY="$HOME/.ssh/github_repo"
TIMESTAMP=$(date +%Y%m%d-%H%M%S)

mkdir -p "$BACKUP_DIR"
# Backup live site without uploads (uploads can be huge; DB is separate)
tar -czf "$BACKUP_DIR/html-$TIMESTAMP.tar.gz" \
  --exclude='uploads' --exclude='.git' --exclude='deploy-backups' \
  -C "$HTML_DIR" . 2>/dev/null || true
echo "Backup: $BACKUP_DIR/html-$TIMESTAMP.tar.gz"

cd "$REPO_DIR"

# Ensure this script stays executable after git reset (reset clears +x on cPanel FS)
chmod +x "$REPO_DIR/deploy.sh" 2>/dev/null || true

echo "Fetching $BRANCH ..."
GIT_SSH_COMMAND="ssh -i $SSH_KEY -o StrictHostKeyChecking=no" git fetch origin "$BRANCH"
GIT_SSH_COMMAND="ssh -i $SSH_KEY -o StrictHostKeyChecking=no" git reset --hard "origin/$BRANCH"
chmod +x "$REPO_DIR/deploy.sh" || true

echo "Copying to $HTML_DIR (preserving .env and uploads/) ..."

# Root dotfiles and config
cp -f "$REPO_DIR/.htaccess"  "$HTML_DIR/.htaccess" 2>/dev/null || true
cp -f "$REPO_DIR/.user.ini"  "$HTML_DIR/.user.ini" 2>/dev/null || true
cp -f "$REPO_DIR/robots.txt" "$HTML_DIR/robots.txt" 2>/dev/null || true

# Root PHP entrypoints — copy each *.php present in repo root
for f in "$REPO_DIR"/*.php; do
  [ -e "$f" ] || continue
  cp -f "$f" "$HTML_DIR/"
done

# Directories — use cp -r (rsync often missing on cPanel)
for d in admin assets config includes; do
  if [ -d "$REPO_DIR/$d" ]; then
    rm -rf "$HTML_DIR/$d"
    cp -r "$REPO_DIR/$d" "$HTML_DIR/"
  fi
done

# Webhook endpoint and deploy script itself must be in public_html for GitHub to hit
cp -f "$REPO_DIR/webhook.php"  "$HTML_DIR/webhook.php" 2>/dev/null || true
cp -f "$REPO_DIR/.cpanel.yml"  "$HTML_DIR/.cpanel.yml" 2>/dev/null || true

# Preserve .env — NEVER overwrite from repo (repo only has .env.example)
if [ ! -f "$HTML_DIR/.env" ] && [ -f "$REPO_DIR/.env.example" ]; then
  cp "$REPO_DIR/.env.example" "$HTML_DIR/.env"
  echo "Created $HTML_DIR/.env from .env.example — EDIT DB creds immediately!"
fi

# Ensure uploads structure exists and is writable (PHP runs as nobody on cPanel)
mkdir -p "$HTML_DIR/uploads" "$HTML_DIR/uploads/staff" "$HTML_DIR/uploads/blocks" "$HTML_DIR/uploads/gallery" 2>/dev/null || true
chmod -R 775 "$HTML_DIR/uploads" 2>/dev/null || chmod -R 777 "$HTML_DIR/uploads" 2>/dev/null || true

# Helpful perms — dirs 755, files 644 (keep uploads 775)
find "$HTML_DIR" -type d -not -path "*/uploads/*" -exec chmod 755 {} \; 2>/dev/null || true
find "$HTML_DIR" -type f -name "*.php" -exec chmod 644 {} \; 2>/dev/null || true

echo "Deployed $TIMESTAMP from $BRANCH to $HTML_DIR"
