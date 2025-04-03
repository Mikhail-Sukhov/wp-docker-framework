// totododo
document.addEventListener('DOMContentLoaded', () => {
   const tableCells = document.querySelectorAll('.l-color-table td');
 
   tableCells.forEach(cell => {
       cell.addEventListener('click', () => {
           // Получаем содержимое псевдоэлемента :before
           const beforeContent = window.getComputedStyle(cell, ':before').content;
 
           // Убираем кавычки из содержимого (если они есть)
           const textToCopy = beforeContent.replace(/['"]/g, '');
 
           // Проверяем, поддерживается ли navigator.clipboard
           if (navigator.clipboard) {
               // Используем современный API
               navigator.clipboard.writeText(textToCopy)
                   .then(() => {
                       console.log('Текст скопирован: ', textToCopy);
                       alert(`Скопировано: ${textToCopy}`);
                   })
                   .catch(err => {
                       console.error('Ошибка при копировании: ', err);
                       alert('Не удалось скопировать текст');
                   });
           } else {
               // Используем старый метод с document.execCommand
               const textArea = document.createElement('textarea');
               textArea.value = textToCopy;
               document.body.appendChild(textArea);
               textArea.select();
 
               try {
                   const successful = document.execCommand('copy');
                   if (successful) {
                       console.log('Текст скопирован: ', textToCopy);
                       alert(`Скопировано: ${textToCopy}`);
                   } else {
                       throw new Error('Не удалось скопировать текст');
                   }
               } catch (err) {
                   console.error('Ошибка при копировании: ', err);
                   alert('Не удалось скопировать текст');
               } finally {
                   document.body.removeChild(textArea);
               }
           }
       });
   });
 });