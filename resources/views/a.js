var chats = {}

chats.participants = [
  {
    id: {
      server: 'c.us',
      user: '6289601416330',
      _serialized: '6289601416330@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '628987351166',
      _serialized: '628987351166@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6285730343064',
      _serialized: '6285730343064@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6285770269605',
      _serialized: '6285770269605@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6285959375675',
      _serialized: '6285959375675@c.us'
    },
    isAdmin: true,
    isSuperAdmin: true
  },
  {
    id: {
      server: 'c.us',
      user: '6282299265151',
      _serialized: '6282299265151@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6289523258649',
      _serialized: '6289523258649@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6285732415700',
      _serialized: '6285732415700@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6285772526036',
      _serialized: '6285772526036@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6283143268303',
      _serialized: '6283143268303@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6289630171792',
      _serialized: '6289630171792@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '35799551166',
      _serialized: '35799551166@c.us'
    },
    isAdmin: false,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '35799557765',
      _serialized: '35799557765@c.us'
    },
    isAdmin: false,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '37254893930',
      _serialized: '37254893930@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '447700066656',
      _serialized: '447700066656@c.us'
    },
    isAdmin: false,
    isSuperAdmin: false
  },
  {
    id: { server: 'c.us', user: '50052682', _serialized: '50052682@c.us' },
    isAdmin: false,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '5511951997476',
      _serialized: '5511951997476@c.us'
    },
    isAdmin: false,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6281234975117',
      _serialized: '6281234975117@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6283141964370',
      _serialized: '6283141964370@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6285714363405',
      _serialized: '6285714363405@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '6285778182243',
      _serialized: '6285778182243@c.us'
    },
    isAdmin: false,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '62895382331666',
      _serialized: '62895382331666@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '62896939683397',
      _serialized: '62896939683397@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '687531520',
      _serialized: '687531520@c.us'
    },
    isAdmin: false,
    isSuperAdmin: false
  },
  {
    id: {
      server: 'c.us',
      user: '5214447008415',
      _serialized: '5214447008415@c.us'
    },
    isAdmin: true,
    isSuperAdmin: false
  }
]

/*async function getGroupAdmins(array) {
     const admins = []
     for (let i = 0; i < array.length; i++) {
          if (!array[i].isAdmin) return
          admins.push(array[i].id._serialized)
     }
     console.log(array)
     return admins
}*/

let getGroupAdmins = array => array.filter(v => v.isAdmin).map(({ id }) => id._serialized)

//var test = getGroupAdmins(chats.participants)
var tesc = getGroupAdmins(chats.participants)
console.log(tesc)

module.exports = { getGroupAdmins }

