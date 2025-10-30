#!/bin/bash

# --- Configuration ---
FTP_HOST="ftp.otlov.my.id"
FTP_USER="otls1946"
FTP_PASS="CgdKhAsEkZFS86"
REMOTE_DIR="/public_html"  # Change to your target directory
# ---------------------

LOCAL_DIR="."                     # Source directory to upload (default: current dir)
# ---------------------

# Check if lftp is installed
if ! command -v lftp &> /dev/null
then
    echo "lftp could not be found. It is *required* for recursive uploads."
        echo "Please install it (e.g., sudo apt install lftp)"
            exit 1
            fi

            echo "Connecting to $FTP_HOST to recursively upload..."

            # lftp commands for a recursive "mirror" upload
            lftp -c "
            set ftp:ssl-allow no;
            open -u $FTP_USER,$FTP_PASS $FTP_HOST;
            lcd \"$LOCAL_DIR\";
            cd \"$REMOTE_DIR\";
            echo 'Starting recursive upload...';
            mirror -R --verbose --continue --parallel=5 . .;
            bye;
            "

            echo "Recursive upload complete."