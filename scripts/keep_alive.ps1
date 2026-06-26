$url = "http://fashion-hub.gt.tc/"
try {
    $response = Invoke-WebRequest -Uri $url -UseBasicParsing -TimeoutSec 30
    $statusCode = $response.StatusCode
    $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    Write-Host "[$date] Pinged $url - Status Code: $statusCode"
    Add-Content -Path "$PSScriptRoot/keep_alive.log" -Value "[$date] Success: Status Code $statusCode"
} catch {
    $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    Write-Host "[$date] Failed to ping $url - Error: $_"
    Add-Content -Path "$PSScriptRoot/keep_alive.log" -Value "[$date] Failed: $_"
}
