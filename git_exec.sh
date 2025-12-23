#!/bin/bash

echo "--- Menjalankan Git Operations ---"

git add .

git checkout develop
input_commit="Enter commit message: "
read -r input
git commit -m "$input_commit"
git push origin develop

echo "Pushed to develop branch"

# Last Update
current_time=$(date "+%Y-%m-%d %H:%M:%S")
jq ".repository.last_commit = \"$current_time\"" config.json > temp.json && mv temp.json config.json

# Last Commit Update by name
input_nama="Masukkan Nama Anda"
read -r input
jq ".repository.last_commit_by = \"$input_nama\"" config.json > temp.json && mv temp.json config.json   

echo "Log: File config.json telah diperbarui pada $current_time oleh $input_nama"
git add config.json
git commit -m "Update last commit info in config.json"
git push origin develop
echo "Updated config.json with last commit info and pushed to develop branch."

# Run stop.sh to stop services