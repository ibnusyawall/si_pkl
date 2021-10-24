const rl = require('readline').createInterface(process.stdin, process.stdout)
const question = q => {
    return new Promise((resolve, reject) => {
        rl.question(q, jawab => !jawab ? reject() : resolve(jawab))
    })
}

question('? Nama atom: ')
  .then(async text => {
      let result = {}
      try {
          let E = await question('? Jumlah E: ')
          if (E >= 2) {
              E -= 2
              result['K'] = {
                  nilai: 2,
                  sisa: E,
              }
         } else if (result['K']) {
              if (result['K'].sisa >= 8)
                  E -= result['K'].nilai
                  result['L'] = {
                      nilai: 8,
                      sisa: E
                  }
          }
      } catch (e) {
          console.log('kamu tidak menjawab soal.')
          rl.close()
      } finally {
          console.log(result)
      }
  })
  .catch(() => rl.close())
//rl.question('berapa umur kamu? ', text => console.log('umur kamu adalah', text, 'tahun'))
