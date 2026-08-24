$ErrorActionPreference = 'Stop'

$viewportWidth = [int]((agent-browser eval "document.documentElement.clientWidth") | ConvertFrom-Json)
$scrollWidth = [int]((agent-browser eval "document.documentElement.scrollWidth") | ConvertFrom-Json)

if ($scrollWidth -gt $viewportWidth) {
    throw "Mobile layout overflows horizontally: scrollWidth=$scrollWidth, viewportWidth=$viewportWidth"
}

Write-Output "Mobile layout fits: scrollWidth=$scrollWidth, viewportWidth=$viewportWidth"
