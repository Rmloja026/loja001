# Fix corrupted Font Awesome link tags across all PHP files
$broken = '<link rel=" stylesheet\ href=\https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css\>'
$correct = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">'

$files = Get-ChildItem -Path ".", "@SERVIDOR" -Filter "*.php" -Recurse -ErrorAction SilentlyContinue
$count = 0

foreach ($f in $files) {
    $raw = [System.IO.File]::ReadAllBytes($f.FullName)
    $text = [System.Text.Encoding]::UTF8.GetString($raw)
    
    if ($text.Contains($broken)) {
        $text = $text.Replace($broken, $correct)
        # Write back preserving UTF-8 without BOM
        $utf8NoBom = New-Object System.Text.UTF8Encoding($false)
        [System.IO.File]::WriteAllText($f.FullName, $text, $utf8NoBom)
        Write-Host "FIXED: $($f.FullName)"
        $count++
    }
}

Write-Host "`nTotal files fixed: $count"
