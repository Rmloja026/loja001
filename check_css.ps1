$cssPath = "c:\Users\studi\Downloads\Loja001 rm\@SERVIDOR\assets\css\black-theme.css"
$bytes = [System.IO.File]::ReadAllBytes($cssPath)
Write-Host "File size: $($bytes.Length) bytes"
Write-Host "First 3 bytes (BOM check): $($bytes[0]),$($bytes[1]),$($bytes[2])"

$text = [System.Text.Encoding]::UTF8.GetString($bytes)
$hasNull = $text.Contains([char]0)
Write-Host "Has null bytes: $hasNull"
Write-Host "Line count: $(($text -split "`n").Count)"

# Check for syntax errors - unbalanced braces
$open = ($text.ToCharArray() | Where-Object { $_ -eq '{' }).Count
$close = ($text.ToCharArray() | Where-Object { $_ -eq '}' }).Count
Write-Host "Opening braces: $open"
Write-Host "Closing braces: $close"

# Check last 200 chars
Write-Host "Last 200 chars:"
Write-Host $text.Substring([Math]::Max(0, $text.Length - 200))
