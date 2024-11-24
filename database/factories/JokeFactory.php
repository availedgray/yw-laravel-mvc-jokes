<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Joke;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Joke>
 */
class JokeFactory extends Factory
{
    protected $model = Joke::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jokes = [
            "A cowboy butcher decided to relocate his fresh meat shop. 'Sorry Folks. I'm pullin' up steaks.'",
            "Why don't skeletons fight each other? They don't have the guts.",
            "I'm reading a book on anti-gravity. It's impossible to put down!",
            "Why was the math book sad? It had too many problems.",
            "What do you call fake spaghetti? An impasta!",
            "I told my wife she should embrace her mistakes. She gave me a hug.",
            "Why did the scarecrow win an award? Because he was outstanding in his field.",
            "What do you call a factory that makes okay products? A satisfactory.",
            "I used to play piano by ear, but now I use my hands.",
            "Why did the bicycle fall over? Because it was two-tired.",
            "I'm reading a book on teleportation. It’s bound to take me places.",
            "What did the ocean say to the beach? Nothing, it just waved.",
            "Why don’t scientists trust atoms? Because they make up everything!",
            "Why can't your nose be 12 inches long? Because then it would be a foot.",
            "What do you call cheese that isn't yours? Nacho cheese.",
            "How do you organize a space party? You planet.",
            "What’s orange and sounds like a parrot? A carrot.",
            "Why don’t skeletons go trick-or-treating? Because they have no body to go with.",
            "Why did the tomato turn red? Because it saw the salad dressing.",
            "Why did the golfer bring an extra pair of pants? In case he got a hole in one.",
            "What do you call a bear with no teeth? A gummy bear.",
            "Why can’t you give Elsa a balloon? Because she’ll let it go.",
            "Why did the computer go to the doctor? It had a virus.",
            "I’m on a seafood diet. I see food and I eat it.",
            "Why was the broom late? It swept in.",
            "What do you call a pig that does karate? A pork chop.",
            "Why did the coffee file a police report? It got mugged.",
            "Why are ghosts bad liars? Because you can see right through them.",
            "What do you call a fish without eyes? Fsh.",
            "What’s brown and sticky? A stick.",
            "Why was the belt arrested? For holding up pants.",
            "What do you call a snowman with a six-pack? An abdominal snowman.",
            "Why did the gym close down? It just didn’t work out.",
            "What did one hat say to the other? Stay here, I’m going on ahead.",
            "Why do cows have hooves instead of feet? Because they lactose.",
            "How does a penguin build its house? Igloos it together.",
            "What do you call a dinosaur with a great vocabulary? A thesaurus.",
            "What do you call an alligator in a vest? An investigator.",
            "Why did the banker switch careers? He lost interest.",
            "Why don’t some couples go to the gym? Because some relationships don’t work out.",
            "What do you call a can opener that doesn’t work? A can’t opener.",
            "Why are elevator jokes so good? They work on many levels.",
            "What did the janitor say when he jumped out of the closet? Supplies!",
            "Why was the math book always worried? It had too many problems.",
            "Why did the scarecrow break up with the crow? He felt like he was just being used for his resources.",
            "What do you call an elephant that doesn’t matter? An irrelephant.",
            "How do you make a tissue dance? Put a little boogie in it.",
            "Why couldn’t the bicycle stand up by itself? It was two-tired.",
            "Why don’t eggs tell jokes? They’d crack each other up.",
            "What do you call a cow with no legs? Ground beef.",
            "What do you call a belt made of watches? A waist of time.",
            "Why was the stadium so cool? It was filled with fans.",
            "Why did the orange stop? It ran out of juice.",
            "Why don’t crabs give to charity? Because they’re shellfish.",
            "Why was the calendar scared? Its days were numbered.",
            "What do you call a sleeping bull? A bulldozer.",
            "Why did the man get hit by a bike every day? He was stuck in a vicious cycle.",
            "Why are frogs so happy? They eat whatever bugs them.",
            "Why did the skeleton stay home from the party? He had no body to go with.",
            "Why did the barber win a race? He knew all the shortcuts.",
            "What do you call a dog magician? A labracadabrador.",
            "Why don’t oysters share their pearls? Because they’re shellfish.",
            "How do you organize a space party? You planet.",
            "Why did the chicken join a band? Because it had the drumsticks.",
            "Why don’t vampires attack Taylor Swift? She has bad blood.",
            "Why was the picture sent to jail? It was framed.",
            "What do you call a bee that can’t make up its mind? A maybe.",
            "Why don’t ants get sick? They have tiny ant-bodies.",
            "What do you call a boomerang that won’t come back? A stick.",
            "Why did the man put his money in the blender? He wanted liquid assets.",
            "What do you call a sleeping T-Rex? A dinosnore.",
            "Why don’t sharks like fast food? Because they can’t catch it.",
            "What do you call a group of musical whales? An orca-stra.",
            "Why do melons have weddings? Because they cantaloupe.",
            "Why was the math teacher afraid of the students? They had too many problems.",
            "Why did the dog sit in the shade? It didn’t want to be a hot dog.",
            "Why don’t skeletons dance? They have no body to dance with.",
            "What do you call a potato with glasses? A spec-tater.",
            "Why did the banana go to the doctor? It wasn’t peeling well.",
            "Why did the man bring a ladder to the bar? He heard the drinks were on the house.",
            "Why did the chicken go to the séance? To talk to the other side.",
            "What did the grape do when it got stepped on? Nothing, but it let out a little wine."
        ];


        return [
            'title' => $this->faker->word(),
            'text' => $this->faker->randomElement($jokes),
            'author_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
