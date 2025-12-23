#!/bin/bash

echo "--- Menjalankan Git Operations ---"

git add .

git checkout develop
<<<<<<< HEAD
input_commit="Enter commit message: "
read -r input
git commit -m "$input_commit"
=======
input="Enter commit message: "
read -r input
git commit -m "$input"
>>>>>>> 0f9422a8cbd64cb9551f2932ca7fdf1e6094cffc
git push origin develop

echo "Pushed to develop branch"

# Last Update
current_time=$(date "+%Y-%m-%d %H:%M:%S")
jq ".repository.last_commit = \"$current_time\"" config.json > temp.json && mv temp.json config.json

# Last Commit Update by name
<<<<<<< HEAD
input_nama="Masukkan Nama Anda"
read -r input
jq ".repository.last_commit_by = \"$input_nama\"" config.json > temp.json && mv temp.json config.json   

echo "Log: File config.json telah diperbarui pada $current_time oleh $input_nama"
=======
input="Masukkan Nama Anda"
jq ".repository.last_commit_by = \"$input\"" config.json > temp.json && mv temp.json config.json   

echo "Log: File config.json telah diperbarui pada $current_time oleh $input"
>>>>>>> 0f9422a8cbd64cb9551f2932ca7fdf1e6094cffc
git add config.json
git commit -m "Update last commit info in config.json"
git push origin develop
echo "Updated config.json with last commit info and pushed to develop branch."

# Run stop.sh to stop services