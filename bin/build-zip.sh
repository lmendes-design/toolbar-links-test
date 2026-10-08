#!/usr/bin/env bash
#
# Build dist/toolbar-links-test.zip for manual install.
# The zip root folder is toolbar-links-test/ and contains only
# toolbar-links-test.php, readme.txt and LICENSE.

set -euo pipefail

SLUG="toolbar-links-test"
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST="$ROOT/dist"
ZIP="$DIST/$SLUG.zip"

FILES=(
	"$SLUG.php"
	"readme.txt"
	"LICENSE"
)

for f in "${FILES[@]}"; do
	if [ ! -f "$ROOT/$f" ]; then
		echo "Missing file: $ROOT/$f" >&2
		exit 1
	fi
done

TMP="$(mktemp -d)"
trap 'rm -rf "$TMP"' EXIT

mkdir -p "$TMP/$SLUG" "$DIST"
for f in "${FILES[@]}"; do
	cp "$ROOT/$f" "$TMP/$SLUG/"
done

rm -f "$ZIP"
(
	cd "$TMP"
	zip -r -X "$ZIP" "$SLUG"
)

echo
echo "Built: $ZIP"
echo
unzip -l "$ZIP"
