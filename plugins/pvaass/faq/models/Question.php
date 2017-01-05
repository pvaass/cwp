<?php namespace pvaass\Faq\Models;

use League\Flysystem\Exception;
use Model;

class Question extends Model
{
    use \October\Rain\Database\Traits\Validation;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'pvaass_faq_questions';
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    public $rules = [
        'question' => 'required',
        'answer' => 'required',
        'category' => 'required'
    ];

    public function getCategoryOptions()
    {
        $options = ['Algemeen', 'Na je zwemdiploma', 'Veiligheid'];
        return array_combine($options, $options);
    }


    public function getPositionOptions()
    {
        $questions = Question::where('category', $this->category)->orderBy('position')->get()->toArray();
        if (empty($questions)) {
            return [0 => 'Niet van toepassing'];
        }
        return array_combine(
            array_column($questions, 'id'),
            array_column($questions, 'question')
        );
    }

    public function beforeSave()
    {
        if ($this->position === "0" || !$this->isDirty('position')) {
            return;
        }

        // Clone because of shenanigans
        $placeAfterId = $this->position;

        $questions = Question::where('category', $this->category)
            ->orderBy('position')->get();

        $placeAfter = Question::findOrFail($placeAfterId);


        foreach ($questions as $question) {
            if ($question->id !== $this->id && $question->position > $placeAfter->position) {
                $question->position = $question->position + 1;
                $question->save();
            }
        }
        $this->position = $placeAfter->position + 1;
    }
}