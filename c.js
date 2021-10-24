class AudioTest {
    constructor(uri) {
        this.uri = uri
    }
    play() {
        return `Ok: ${this.uri}`
    }
}


var axios = require('axios')

var uri = 'https://www.kuwo.cn/url?format=mp3&response=url&type=convert_url3&br=128kmp3&from=web&t=1575964755748&reqId=f5f45551-1b22-11ea-9621-9fa471ffaaa8&rid=MUSIC_140002244'

axios.get(uri)
    .then(res => {
        let { url } = res.data
        const audio = new AudioTest(url)
        console.log(audio.play())
    }).catch(e => console.log(e.responae.data))
