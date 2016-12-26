<template>
    <div class="control">
        <label class="label">Hours</label>
        <input class="input" type="number" step="0.25" min="0.25" max="8.50" placeholder="0.00" @input="$emit('input', $event.target.value)">
    </div>
</template>

<script>
export default {
    name: 'Hours'
}
</script>
