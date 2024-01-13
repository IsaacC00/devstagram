<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     // un factor nos ayuda hacer testing a nuestra base de datos 
            // nos ayuda a sustir las pruebas comunes y para saber si la base 
            // de datos guarda informacion correctamente, en este caso de los 
            // post de usuarios 
            // php artisa make:fatory FactoryPrueba
            // destro del retunr podemos asignar nuestro fakedata 
            // con la libreria faker que implementa laravel
    public function definition(): array
    {
        return [
            'titulo'=>$this->faker->sentence(5),
            'descripcion'=>$this->faker->sentence(20),
            'imagen'=>$this->faker->uuid().'.jpg',
            'user_id'=>$this->faker->randomElement([1,2,3,4])
        ];
    }
}

//para correr nuestro factory debemos utilziar tinker 
// php artisan tinker
//encontrar si un usario existe
//$usuario = User::find(2)
//pero antes de ejecutar el factory debemos ejecutar el siguietne comnado
//composer dump-autoload
// ejecutamos nuestro factory de la siguiente manera
// Post::factory{}->times(200)-create();
// para 'deshacer' este factory debemos ejecutar lo siguiente 
// php artisan migrate:rollback --step=1