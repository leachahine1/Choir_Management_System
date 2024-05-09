from music21 import converter, stream
from ngrams_preprocessing import midi_file_path1_mxl
import warnings

def adjust_tempo_in_musicxml(file_path, new_tempo):
    # Load MusicXML file
    score = converter.parse(file_path)

    # Get the current tempo
    mm_marks = score.metronomeMarkBoundaries()
    if mm_marks:
        current_tempo = mm_marks[0][2].number
    else:
        # If no metronome mark is defined, use a default tempo of 120
        current_tempo = 120

    # Calculate the ratio of the new tempo to the current tempo
    tempo_ratio = new_tempo / current_tempo

    # Adjust tempo
    for note_or_rest in score.flat.notesAndRests:
        # Adjust duration of notes and rests
        if note_or_rest.duration is not None:
            note_or_rest.duration.quarterLength *= tempo_ratio

    # Save the adjusted MusicXML file, overwriting the original file
    score.write('musicxml', file_path)

    return file_path


def map_notes_to_measures(file_path):
    # Load the MusicXML file
    score = converter.parse(file_path)

    # Create an empty list to store notes mapped to measures
    notes_by_measure = []

    # Iterate over each part in the score
    for part in score.parts:
        # Iterate over each measure in the part
        for measure in part.getElementsByClass('Measure'):
            # Create a list to store notes in the measure
            measure_notes = []

            # Iterate over each note in the measure
            for note in measure.notes:
                # Append the pitch of the note to the list of notes
                measure_notes.append(str(note.pitch))

            # Add the list of notes to the list of measures
            notes_by_measure.append(measure_notes)

    return notes_by_measure

def mapping_to_measures(measures, list):
    mapped_measures = {}
    list_index = 0

    for i, measure in enumerate(measures):
        mapped_measures[f"Measure {i + 1}"] = list[list_index:list_index + len(measure)]
        list_index += len(measure)

    return mapped_measures

warnings.filterwarnings("ignore")


adjusted_file_path = adjust_tempo_in_musicxml(midi_file_path1_mxl, 120)

notes_by_measure = map_notes_to_measures(adjusted_file_path)
