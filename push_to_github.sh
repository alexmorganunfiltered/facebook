#!/usr/bin/env bash
# Push aswproject_dev only to GitHub (migrantsdiary/facebook).
#
# IMPORTANT: This app must use its OWN .git inside aswproject_dev/.
# Never run git push from the parent custom/ monorepo for this remote.
#
# Token: /etc/webapp/config/.gitTokens → migrantsdiary=<PAT with repo scope>
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

REPO="${MIGRANTSDIARY_GIT_REPO:-https://github.com/migrantsdiary/facebook.git}"
BRANCH="${GITHUB_BRANCH:-main}"
TOKEN_FILE="/etc/webapp/config/.gitTokens"

if [[ ! -r "$TOKEN_FILE" ]]; then
  echo "Error: token file not found: $TOKEN_FILE"
  echo "Add: migrantsdiary=<GitHub PAT>"
  exit 1
fi

TOKEN="${MIGRANTSDIARY_GIT_TOKEN:-}"
if [[ -z "$TOKEN" ]]; then
  TOKEN="$(grep -E '^migrantsdiary=' "$TOKEN_FILE" 2>/dev/null | head -1 | cut -d= -f2- | tr -d '\r' | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')"
fi

if [[ -z "$TOKEN" ]]; then
  echo "Error: no migrantsdiary= entry in $TOKEN_FILE"
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

git push "https://x-access-token:${TOKEN}@github.com/migrantsdiary/facebook.git" "HEAD:${BRANCH}" --force-with-lease

echo "Done. Site: https://migrantsdiary.github.io/facebook/"
echo "Enable Pages: repo Settings → Pages → Source: GitHub Actions"
