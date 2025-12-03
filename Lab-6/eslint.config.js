import js from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'
import skipFormatting from '@vue/eslint-config-prettier/skip-formatting'

export default [
  {
    name: 'app/files-to-lint',
    files: ['**/*.{js,mjs,jsx,vue}'],
  },
  {
    name: 'app/files-to-ignore',
    ignores: ['**/dist/**', '**/dist-ssr/**', '**/coverage/**'],
  },

  js.configs.recommended,
  ...pluginVue.configs['flat/essential'],

  // НАЙВАЖЛИВІШЕ:
  {
    // Дозволяємо браузерні команди
    languageOptions: {
      globals: {
        window: 'readonly',
        document: 'readonly',
        console: 'readonly',
        alert: 'readonly'
      }
    },
    // Вимикаємо суворі правила
    rules: {
      'vue/multi-word-component-names': 'off',
      'no-unused-vars': 'off', // Не буде сваритись на router
      'no-undef': 'off'
    }
  },

  skipFormatting,
]
