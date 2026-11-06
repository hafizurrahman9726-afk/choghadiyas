#!/usr/bin/env python3
"""
Deploy Author Bio updates to Hostinger Staging Environment ONLY:
Target: /public_html/staging-test/
Files:
- templates/single.php
- templates/home.php
- assets/css/choghadiya-theme.css
"""

import os
import ftplib
import sys

FTP_HOST = "89.117.157.182"
FTP_PORT = 21
FTP_USER = "u206523498.choghadiyas.in"
FTP_PASS = "Kaloup&sd54#"

FILES_TO_DEPLOY = [
    {
        "local": "public/hostinger-deployment/templates/single.php",
        "remote_dir": "staging-test/templates",
        "remote_filename": "single.php"
    },
    {
        "local": "public/hostinger-deployment/templates/home.php",
        "remote_dir": "staging-test/templates",
        "remote_filename": "home.php"
    },
    {
        "local": "public/hostinger-deployment/assets/css/choghadiya-theme.css",
        "remote_dir": "staging-test/assets/css",
        "remote_filename": "choghadiya-theme.css"
    }
]

def main():
    print("=== Connecting to Hostinger FTP ===")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, FTP_PORT, timeout=30)
    ftp.login(FTP_USER, FTP_PASS)
    print("Logged in successfully. Remote PWD:", ftp.pwd())

    for item in FILES_TO_DEPLOY:
        local_path = item["local"]
        remote_dir = item["remote_dir"]
        remote_name = item["remote_filename"]

        if not os.path.exists(local_path):
            print(f"ERROR: Local file does not exist: {local_path}")
            sys.exit(1)

        local_size = os.path.getsize(local_path)
        print(f"\nProcessing {remote_name} (Local size: {local_size:,} bytes)...")

        ftp.cwd("/public_html/" + remote_dir)
        print(f"Changed to remote directory: {ftp.pwd()}")

        # Upload binary
        with open(local_path, "rb") as f:
            ftp.storbinary(f"STOR {remote_name}", f)

        # Verify size
        remote_size = ftp.size(remote_name)
        print(f"Uploaded {remote_name} -> Remote size: {remote_size:,} bytes")
        if remote_size != local_size:
            print(f"WARNING: Size mismatch for {remote_name}: local {local_size} vs remote {remote_size}")
        else:
            print(f"SUCCESS: {remote_name} verified ({remote_size:,} bytes).")

    ftp.quit()
    print("\n=== All staging uploads completed successfully! ===")

if __name__ == "__main__":
    main()
