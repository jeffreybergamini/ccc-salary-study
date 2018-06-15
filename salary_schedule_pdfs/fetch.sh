while read url; do wget -x "$url"; done < urls.txt
