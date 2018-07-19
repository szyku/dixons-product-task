# Hello

First of all, thank you for opening and willing to read this 'motivation' file. 
Surely, you are very busy, and I feel flattered just by the fact that you've decided to check this code, and, maybe, give me feedback. 

# Down to business

### How is this structured?

I really didn't have much hints on how to implement this even though the instruction on what should be presented was clear.
Because I wasn't sure if I am allowed to use external packages, I decided to decouple the application itself (src/Application and src/Implementation) from any form of vendor.
I had a hunch you don't really care about an actually working example, but either way, I added a HTTP implementation (src/HTTP)
combined from Symfony component although specifications and tests would be enough to prove that the code does what it should.

### What about the tests?

I decided to stick to specs for the App part with some minor units.
Of course, I would also add acceptance or functional tests for endpoints, but this simple app is already over-engineered.

