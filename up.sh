#!/bin/bash

# --- Configuration ---
FTP_HOST="ftp.otlov.my.id"
FTP_USER="otls1946"
FTP_PASS="CgdKhAsEkZFS86"
REMOTE_DIR="/public_html"  # Change to your target directory
# ---------------------

# Check if lftp is installed
if ! command -v lftp &> /dev/null
then
    echo "lftp could not be found. Please install it first."
        exit 1
        fi

        echo "Connecting to $FTP_HOST..."

        # lftp commands
        lftp -c "
        set ftp:ssl-allow no;
        open -u $FTP_USER,$FTP_PASS $FTP_HOST;
        lcd .;
        cd \"$REMOTE_DIR\";
        echo 'Uploading files...';
        mput *;
        bye;
        "

        echo "Upload complete."
        exit 0