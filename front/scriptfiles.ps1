# Crée une liste de fichiers
$files = @(
  "StepUser.vue"         
  "StepChildren.vue "   
  "StepGuardians.vue  "  
  "StepPresence.vue"     
  "StepSummary.vue "
)

# Contenu de base du template
$template = @"
<script setup>
// TODO: Implement view logic
</script>

<template>
  <div class='p-6'>
    <h1 class='text-2xl font-bold'>[TITLE]</h1>
  </div>
</template>
"@

# Crée les fichiers avec titre personnalisé
foreach ($file in $files) {
  $title = ($file -replace ".vue", "") -replace "([a-z])([A-Z])", '$1 $2'
  $content = $template -replace "\[TITLE\]", $title
  Set-Content -Path $file -Value $content -Encoding UTF8
}