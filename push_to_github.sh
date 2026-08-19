#!/usr/bin/env bash
# Push aswproject_dev only to GitHub (alexmorganunfiltered/facebook).
#
# IMPORTANT: This app must use its OWN .git inside aswproject_dev/.
# Never run git push from the parent custom/ monorepo for this remote.
#
# Token: /etc/webapp/config/.gitTokens → alexmorganunfiltered=<PAT>
#        (falls back to migrantsdiary= if the old key is still present)
#
# Usage:
#   ./push_to_github.sh
#   ./push_to_github.sh "commit message"
set -euo pipefail

ROOT="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT"

if [[ "$(basename "$ROOT")" != "aswproject_dev" ]]; then
  echo "Error: run this script from aswproject_dev only."
  exit 1
fi

TOPLEVEL="$(git rev-parse --show-toplevel 2>/dev/null || true)"
if [[ "$TOPLEVEL" != "$ROOT" ]]; then
  echo "Error: git root is not aswproject_dev."
  echo "  Expected: $ROOT"
  echo "  Found:    ${TOPLEVEL:-not a git repository}"
  echo ""
  echo "Fix (one time):"
  echo "  cd $ROOT"
  echo "  git init"
  echo "  git add ."
  echo '  git commit -m "Initial site"'
  echo "  git branch -M main"
  exit 1
fi

REPO="${ALEXMORGAN_GIT_REPO:-https://github.com/alexmorganunfiltered/facebook.git}"
PAGES_URL="${ALEXMORGAN_PAGES_URL:-https://alexmorganunfiltered.github.io/facebook/}"
BRANCH="${GITHUB_BRANCH:-main}"
TOKEN_FILE="/etc/webapp/config/.gitTokens"

if [[ ! -r "$TOKEN_FILE" ]]; then
  echo "Error: token file not found: $TOKEN_FILE"
  echo "Add: alexmorganunfiltered=<GitHub PAT>"
  exit 1
fi

TOKEN="${ALEXMORGAN_GIT_TOKEN:-}"
if [[ -z "$TOKEN" ]]; then
  TOKEN="$(grep -E '^alexmorganunfiltered=' "$TOKEN_FILE" 2>/dev/null | head -1 | cut -d= -f2- | tr -d '\r' | sed 's/^[[:space:]]*//;s/[[:space:]]*$//' || true)"
fi
if [[ -z "$TOKEN" ]]; then
  TOKEN="$(grep -E '^migrantsdiary=' "$TOKEN_FILE" 2>/dev/null | head -1 | cut -d= -f2- | tr -d '\r' | sed 's/^[[:space:]]*//;s/[[:space:]]*$//' || true)"
fi

if [[ -z "$TOKEN" ]]; then
  echo "Error: no alexmorganunfiltered= (or migrantsdiary=) entry in $TOKEN_FILE"
  exit 1
fi

if [[ $# -gt 0 ]]; then
  git add -A
  if git diff --cached --quiet; then
    echo "No staged changes to commit."
  else
    git commit -m "$1"
  fi
fi

OBJECTS="$(git rev-list --count HEAD 2>/dev/null || echo 0)"
FILES="$(git ls-files | wc -l | tr -d ' ')"
echo "Pushing aswproject_dev only ($FILES tracked files, $OBJECTS commits)..."
echo "Remote: $REPO"

git push "https://x-access-token:${TOKEN}@${REPO#https://}" "HEAD:${BRANCH}" --force

if git remote get-url origin >/dev/null 2>&1; then
  git remote set-url origin "$REPO"
else
  git remote add origin "$REPO"
fi

echo "Done. Site: $PAGES_URL"
echo "Enable Pages: repo Settings → Pages → Source: GitHub Actions"
